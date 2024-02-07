import { BrowserRouter } from "react-router-dom";
import TopHeader from '../src/components/TopHeader';
import { AuthProvider } from "./providers/AuthProvider";
import MyRoute from "./routes/MyRoute";

function App() {
  return (
    <BrowserRouter>
      <AuthProvider>
        <MyRoute/>
      </AuthProvider>
    </BrowserRouter>
  )
}

export default App
